<template>
  <div class="form-outline">
    <input autocomplete="off"
           id="search-country"
           @blur="closedMenu()"
           type="text"
           class="form-control w-100"
           :name="'search-' + name"
           v-model="search">
    <label for="search-country"
           class="form-label">
      Страна
    </label>

    <div class="form-notch">
      <div class="form-notch-leading"></div>
      <div class="form-notch-middle"></div>
      <div class="form-notch-trailing"></div>
    </div>

    <div class="dropdown w-100">
      <input type="hidden"
             :value="selected_country.id"
             :name="name"
             :id="id">

      <div class="dropdown-menu mt-2"
           :class="this.show ? 'show' : ''"
           style="width: 100%!important;">
        <h6 class="dropdown-header">
          Выберите страну
        </h6>
        <a v-if="countries.length > 0"
           @click="setCountry(country)"
           v-for="country in countries"
           class="dropdown-item pointer-events-auto">
          {{ country.name }}
        </a>
        <h5 v-if="countries.length === 0"
            class="dropdown-header">
          Нет стран
        </h5>
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
      type: Object|null,
      required: false
    }

  },
  mounted: function () {
    if (this.country_props) {
      $('#search-country').addClass('active')
      this.selected_country = this.country_props
      this.$emit('set', this.selected_country);
      this.search = this.country_props.name
    }
    this.watcher = this.$watch('search', function (n, o) {
      this.watcherSearch(n, o)
    })
  },
  methods: {
    closedMenu() {
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
    setCountry(country) {
      this.watcher()
      this.selected_country = country
      this.$emit('set', country);
      this.show = false
      this.search = country.name
      this.watcher = this.$watch('search', function (n, o) {
        this.watcherSearch(n, o)
      })
    },
    watcherSearch: function (n, o) {
      this.show = true
      axios.post('/api/countries', {
        name: n
      })
        .then(response => {
          this.countries = response.data.countries
        })
    },
  }
}
</script>

<style scoped>

</style>
