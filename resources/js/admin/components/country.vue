<template>
  <div class="form-group">
    <label :for="id" class="required">Страна</label>
    <div :class="'dropdown w-full ' + (this.show ? 'show' : '')">
      <input type="hidden" :value="selected_country.id" :name="name" :id="id">
      <input autocomplete="off" @blur="closedMenu()" type="text" placeholder="Страна" class="form-control w-full" :name="'search-' + name" v-model="search">
      <div class="dropdown-menu mt-20">
        <h6 class="dropdown-header">Выберите страну</h6>
        <a v-if="countries.length > 0" @click="setCountry(country)" v-for="country in countries " class="dropdown-item pointer-events-auto">{{ country.name }}</a>
        <h5 v-if="countries.length === 0" class="dropdown-header">Нет стран</h5>
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
      countries: [],
      selected_country: {
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
    country_props: {
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
      if (this.countries.length === 0) {
        this.watcher()
        this.show = false
        this.countries = []
        this.search = this.selected_country.name
        this.watcher = this.$watch('search', function (n, o) {
          this.watcherSearch(n, o)
        })
      }
    },
    setCountry (country) {
      this.watcher()
      this.selected_country = country
      this.show = false
      this.search = country.name
      this.watcher = this.$watch('search', function (n, o) {
        this.watcherSearch(n, o)
      })
    },
    watcherSearch: function(n, o) {
      this.show = true
      axios.post('/api/countries', {
        name: n
      })
        .then(response => {
          this.countries = response.data.countries
        })
    }
  }
}
</script>

<style scoped>

</style>
