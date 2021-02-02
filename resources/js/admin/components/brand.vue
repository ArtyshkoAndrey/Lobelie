<template>
  <div class="form-group">
    <div :class="'dropdown w-full ' + (this.show ? 'show' : '')">
      <input type="hidden" :value="selected_brand.id" :name="name" :id="id">
      <label :for="id" class="required">Бренд</label>
      <div class="input-group w-full">
        <input autocomplete="off" @blur="closedMenu()" type="text" placeholder="Бренд" class="form-control" :name="'search-' + name" v-model="search">
        <div class="input-group-append">
          <span class="input-group-text"><i class="bx bx-down-arrow-alt"></i></span>
        </div>
      </div>
      <div class="dropdown-menu mt-20">
        <h6 class="dropdown-header">Выберите категория</h6>
        <a v-if="brands.length > 0" @click="setCountry(brand)" v-for="brand in brands" class="dropdown-item pointer-events-auto">{{ brand.name }}</a>
        <h5 v-if="brands.length === 0" class="dropdown-header">Нет брендов</h5>
      </div>
      <div class="form-text font-size-10">
        Начните писать, что бы увидеть варианты
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "brand",
  data() {
    return {
      show: false,
      search: '',
      brands: [],
      selected_brand: {
        id: null,
        name: null
      },
      watcher: null
    }
  },
  props: {
    id: {
      type: String,
    },
    name: {
      type: String,
    },
    brand_props: {
      type: Object|null
    }

  },
  created: function () {
    if (this.brand_props) {
      this.selected_brand = this.brand_props
      this.search = this.brand_props.name
    }
    this.watcher = this.$watch('search', function (n, o) {
      this.watcherSearch(n, o)
    })
  },
  methods: {
    closedMenu () {
      if (this.brands.length === 0) {
        this.watcher()
        this.show = false
        this.brands = []
        this.search = this.selected_brand.name
        this.watcher = this.$watch('search', function (n, o) {
          this.watcherSearch(n, o)
        })
      }
    },
    setCountry (brand) {
      this.watcher()
      this.selected_brand = brand
      this.show = false
      this.search = brand.name
      this.watcher = this.$watch('search', function (n, o) {
        this.watcherSearch(n, o)
      })
    },
    watcherSearch: function(n, o) {
      this.show = true
      axios.post('/api/brands', {
        name: n
      })
        .then(response => {
          this.brands = response.data.brands
        })
    }
  }
}
</script>

<style scoped>

</style>
