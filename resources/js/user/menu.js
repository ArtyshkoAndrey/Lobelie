$(window).ready(function() {
  let toggle = $('#nav-toggle')
  let dropdownPage = $('#menu-dropdown-page')
  let search = $('#search')
  let searchInput = $('.search-input')
  let searchButton = $('.search-button')

  toggle.click(function () {
    if (toggle.hasClass('open')) {
      search.removeClass('open')
    }

    toggle.toggleClass('open')
    dropdownPage.toggleClass('open')
  })

  window.toggleSearch = function() {
    search.toggleClass('open')
  }

  searchInput.focusin(function() {
    searchInput.addClass('active')
    searchButton.addClass('active')
  })

  searchInput.focusout(function() {
    if (searchInput.val().length === 0) {
      searchButton.removeClass('active')
      searchInput.removeClass('active')
    }
  })
})
