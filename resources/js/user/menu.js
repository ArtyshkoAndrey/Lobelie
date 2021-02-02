$(window).ready(function() {
  let toggle = $('#nav-toggle')
  let dropdownPage = $('#menu-dropdown-page')
  let search = $('#search')

  toggle.click(function () {
    $(toggle).toggleClass('open')
    dropdownPage.toggleClass('open')
  })

  function toggleSearch() {
    search.toggleClass('open')
  }
})
