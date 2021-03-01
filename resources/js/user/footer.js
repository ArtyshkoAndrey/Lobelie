$(window).ready(function() {
  let subscribeInput = $('.subscribe-input')
  let subscribeButton = $('.subscribe-button')

  subscribeInput.focusin(function() {
    subscribeInput.addClass('active')
    subscribeButton.addClass('active')
  })

  subscribeInput.focusout(function() {
    if (subscribeInput.val().length === 0) {
      subscribeButton.removeClass('active')
      subscribeInput.removeClass('active')
    }
  })
})
