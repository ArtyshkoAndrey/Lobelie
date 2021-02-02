<template>
  <div class="form-group">
    <label :for="id" class="required">Страна</label>
    <div :class="'dropdown w-full ' + (this.show ? 'show' : '')">
      <input type="hidden" :value="selected_city.id" :name="name" :id="id">
      <input autocomplete="off" @blur="closedMenu()" type="text" placeholder="Город" class="form-control w-full" :name="'search-' + name" v-model="search">
      <div class="dropdown-menu mt-20">
        <h6 class="dropdown-header">Выберите страну</h6>
        <a v-if="cities.length > 0" @click="setCity(city)" v-for="city in cities " class="dropdown-item pointer-events-auto">{{ city.search_name }}</a>
        <h5 v-if="cities.length === 0" class="dropdown-header">Нет городов</h5>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "country",
  data() {
    return {
      show: false,
      search: '',
      cities: [],
      selected_city: {
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
    city_props: {
      required: false
    }

  },
  created: function () {
    this.watcher = this.$watch('search', function (n, o) {
      this.watcherSearch(n, o)
    })
  },
  methods: {
    closedMenu () {
      if (this.cities.length === 0) {
        this.watcher()
        this.show = false
        this.countries = []
        this.search = this.selected_city.name
        this.watcher = this.$watch('search', function (n, o) {
          this.watcherSearch(n, o)
        })
      }
    },
    setCity (city) {
      this.watcher()
      this.selected_city = city
      this.show = false
      this.search = city.name
      this.watcher = this.$watch('search', function (n, o) {
        this.watcherSearch(n, o)
      })
    },
    watcherSearch: function(n, o) {
      this.show = true
      axios.post('/api/cities', {
        name: n
      })
        .then(response => {
          this.cities = response.data.cities
        })
    }
  }
}
</script>

<style scoped>

</style>
