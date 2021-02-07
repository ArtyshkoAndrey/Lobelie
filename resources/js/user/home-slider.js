window.onload = function() {
  let current_slide = 1
  let next_slide = 2
  let slides_amount = $('.slide-wrapper .slide').length

  $('.next-wrapper').click(function() {
    if (current_slide === slides_amount) {
      current_slide = 1
    } else {
      current_slide++
    }

    if (next_slide === slides_amount) {
      next_slide = 1
    } else {
      next_slide++
    }

    $('.slide-wrapper .slide.active').removeClass('active')
    $('.slide-wrapper .slide[slide-index=' + current_slide + ']').addClass('active')

    $('.dots .dot.active').removeClass('active')
    $('.dots .dot[slide-index=' + current_slide + ']').addClass('active')

    $('.next-wrapper .next-slide.active').removeClass('active')
    $('.next-wrapper .next-slide[slide-index=' + next_slide + ']').addClass('active')

    $('.subtitle-wrapper .subtitle.active').removeClass('active')
    $('.subtitle-wrapper .subtitle[text-index=' + current_slide + ']').addClass('active')
  })
}
