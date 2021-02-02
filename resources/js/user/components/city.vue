<template>
  <div class="form-outline">
    <input autocomplete="false"
           id="search-city"
           @blur="closedMenu()"
           type="text"
           class="form-control w-100"
           :name="'search-' + name"
           v-model="search"
    >
    <label for="search-city"
           class="form-label">
      Город
    </label>

    <div class="form-notch">
      <div class="form-notch-leading"></div>
      <div class="form-notch-middle"></div>
      <div class="form-notch-trailing"></div>
    </div>

    <div class="dropdown w-100">
      <input type="hidden"
             :value="selected_city.id"
             :name="name"
             :id="id">

      <div class="dropdown-menu mt-2"
           :class="this.show ? 'show' : ''"
            style="width: 100%!important;">
        <h6 class="dropdown-header">
          Выберите город
        </h6>
        <a v-if="cities.length > 0"
           @click="setCity(city)"
           v-for="city in cities"
           class="dropdown-item pointer-events-auto">
          {{ city.name }}
        </a>
        <h5 v-if="cities.length === 0"
            class="dropdown-header">
          Нет городов
        </h5>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "city",
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
      type: Object|null
    }

  },
  mounted: function () {
    if (this.city_props) {
      $('#search-city').addClass('active')
      this.selected_city = this.city_props
      this.$emit('set', this.selected_city);
      this.search = this.city_props.name
    }
    this.watcher = this.$watch('search', function (n, o) {
      this.watcherSearch(n, o)
    })
  },
  methods: {
    closedMenu () {
      if (this.cities.length === 0) {
        this.watcher()
        this.show = false
        this.cities = []
        this.search = this.selected_city.name
        this.watcher = this.$watch('search', function (n, o) {
          this.watcherSearch(n, o)
        })
      }
    },
    setCity (city) {
      this.watcher()
      this.selected_city = city
      this.$emit('set', city);
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
