<template>
  <div class="form-group">
    <div :class="'dropdown w-full ' + (this.show ? 'show' : '')">
      <input type="hidden" :value="selected_category.id" :name="name" :id="id">
      <label :for="id" class="required">Изделие</label>
      <div class="input-group w-full">
        <input autocomplete="off" @blur="closedMenu()" type="text" placeholder="Изделие" class="form-control w-full" :name="'search-' + name" v-model="search">
        <div class="input-group-append">
          <span class="input-group-text"><i class="bx bx-down-arrow-alt"></i></span>
        </div>
      </div>
      <div class="dropdown-menu mt-20">
        <h6 class="dropdown-header">Выберите изделие</h6>
        <a v-if="categories.length > 0" @click="setCountry(category)" v-for="category in categories" class="dropdown-item pointer-events-auto">{{ category.search_name }}</a>
        <h5 v-if="categories.length === 0" class="dropdown-header">Нет изделий</h5>
      </div>
    </div>
    <div class="form-text font-size-10">
      Начните писать, что бы увидеть варианты
    </div>
  </div>
</template>

<script>
export default {
  name: "category",
  data() {
    return {
      show: false,
      search: '',
      categories: [],
      selected_category: {
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
    category_props: {
      type: Object|null
    }
  },
  created: function () {
    if (this.category_props) {
      this.selected_category = this.category_props
      this.search = this.category_props.search_name
    }
    this.watcher = this.$watch('search', function (n, o) {
      this.watcherSearch(n, o)
    })
  },
  methods: {
    closedMenu () {
      if (this.categories.length === 0) {
        this.watcher()
        this.show = false
        this.categories = []
        this.search = this.selected_category.search_name
        this.watcher = this.$watch('search', function (n, o) {
          this.watcherSearch(n, o)
        })
      }
    },
    setCountry (category) {
      this.watcher()
      this.selected_category = category
      this.show = false
      this.search = category.search_name
      this.watcher = this.$watch('search', function (n, o) {
        this.watcherSearch(n, o)
      })
    },
    watcherSearch: function(n, o) {
      this.show = true
      axios.post('/api/categories', {
        name: n
      })
        .then(response => {
          this.categories = response.data.categories
        })
    }
  }
}
</script>

<style scoped>

</style>
