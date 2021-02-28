/*
 * Copyright (c) 2020. Данный файл является интелектуальной собственостью Fulliton.
 * Я буду рад если вы будите вносить улучшения, всегда жду ваших пул реквестов
 */

require('./bootstrap.js');
import * as mdb from 'mdb-ui-kit'; // lib
import store from "./store";
window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', import('./components/ExampleComponent.vue'));
Vue.prototype.$cost = function (number) {
  return new Intl.NumberFormat('ru-RU').format(Math.ceil(number));
};
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.config.productionTip = false
Vue.config.devtools = true;
Vue.config.performance = true;

const app = new Vue({
  el: '#app',
  store: store,
  data() {
    return {
      test: !process.env.NODE_ENV || process.env.NODE_ENV === 'development',
      cartLoader: true,
      selectSkus: null,
    };
  },
  async created () {
    await window.axios.post('/auth/check')
      .then(response => {
        this.$store.commit('auth', response.data);
        if(this.test) {
          console.log('Auth bool server', response.data);
        }
      })
      .catch(response => {
        console.error(response);
      });

    await window.axios.post('/api/currency/' + this.$store.state.currency_id)
      .then(response => {
        this.$store.commit('currency', response.data);
        if(this.test) {
          console.log('Server return currency', response.data);
        }
      })
      .catch(error => {
        alert(error.response.data.error);
      });

    await window.axios.post('/api/products', {
      products_skuses_ids: this.$store.state.cart.items.map(el => el.id),
    })
      .then(response => {
        this.$store.commit('setProducts', response.data);
        let flag = false;
        try {
          this.$store.state.cart.items.map(item => {
            let product = this.$store.state.cart.products.find(el => el.product_skuses.some(sk => sk.id === item.id));
            if (product === undefined) {
              flag = true;
              this.$store.commit('removeItem', item.id);
            }
          });
        } catch ($e) {
          console.log($e);
        }
        if (flag) {
          window.Swal.fire({
            icon: 'info',
            title: 'Товар в вашей корзине закончился',
            text: 'Товар из вашей корзины только-что закончился и был автоматически удален из корзины',
            width: '40rem',
          });
        }

      })
      .catch(error => {
        alert(error.response.data);
      });

    this.cartLoader = false;
  },
  computed: {
    productsCart() {
      return this.$store.state.cart.items.map(item => {
        let product = this.$store.state.cart.products.find(el => el.product_skuses.some(sk => sk.id === item.id));

        if (product) {
          product = Object.assign({}, product);
          product.item = item;
          product.product_skuses = Object.values(product.product_skuses);
          product.skus = product.product_skuses;
          product.skus = product.product_skuses.find(el => el.id === item.id);
          return product;
        } else {
          this.$store.commit('removeItem', item.id);
        }
      })
    }
  },
  destroyed () {
    this.$store.state.cart.products = [];
  },
  methods: {
    addFavor (id) {
      window.axios.post('/profile/favorites', {id: id, type: 'add'})
        .then(response => {
          if (response.data.status) {
            window.Swal.fire({
              icon: 'success',
              title: 'Товар добавлен в избранные',
              width: '40rem',
            });
          }
        })
        .catch(error => {
          window.Swal.fire({
            icon: 'error',
            title: error.response.data.message ?? error.response.data.errors[0].message,
            width: '40rem',
          });
        });
    },
    deleteFavor (id, deleting) {
      window.axios.post('/profile/favorites', {id: id, type: 'delete'})
        .then(response => {
          if (response.data.status) {
            window.Swal.fire({
              icon: 'success',
              title: 'Товар удалён из избранных',
              width: '40rem',
            })
              .then(() => {
                if (deleting)
                  $('#product-item-' + id).parent().remove();
              });
          }
        })
        .catch(error => {
          window.Swal.fire({
            icon: 'error',
            title: error.response.data.message ?? error.response.data.errors[0].message,
            width: '40rem',
          });
        });
    },
  },
});
