
const domElements = {}

const initAnchors = (_anchorNav) => {
  domElements.anchorNav = _anchorNav
  const anchors = domElements.anchorNav.querySelectorAll('a')

  updateAnchorAccessability(anchors)
  wrapAllPageAnchorBlocks()

  window.addEventListener('scroll', () => handleScroll(anchors))
  handleScroll(anchors)
}

const updateAnchorAccessability = anchors => {
  for (anchor of anchors) {
    const { anchor: appliedAnchor, parentAnchor } = anchor.dataset

    if (parentAnchor !== appliedAnchor) {
      const parent = document.querySelector(`[data-anchor="${parentAnchor}"]`)
      const ariaOwns = parent.getAttribute('aria-owns')

      const childIds = ariaOwns ? `${ariaOwns} ${appliedAnchor}` : appliedAnchor

      parent.setAttribute('aria-owns', childIds)
    }
  }
}

const wrapAllPageAnchorBlocks = () => {
  /*
  * To utilise position sticky, we need a parent element of 100% height. The way Elementor adds the elements into it's own wrapper,
  * doing this only in CSS means if there was a secondary anchor block used for sub pages, it'd be pushed out of the bottom
  * of the content. To get around this, we add an extra wrapping element to all the elementor-widgeton-this-page blocks.
  */

  // Elementor uses a generic class, so we need the anchor block element first
  const pageAnchorBlock = document.querySelector('.elementor-widget-on-this-page')
  const wrappingElementorElement = pageAnchorBlock?.closest('.elementor-widget-wrap')

  if (!wrappingElementorElement) return

  const newWrapper = `<div class="sticky-wrapper">${wrappingElementorElement.innerHTML}</div>`
  wrappingElementorElement.style.height = '100%'

  wrappingElementorElement.innerHTML = newWrapper
}

const handleScroll = _anchors => {
  updateActiveAnchor(_anchors)
}

const updateActiveAnchor = anchors => {
  const headings = [...document.querySelectorAll('.elementor-widget-heading')].filter(({ id }) => id)
  const anchorList = [...anchors]
  const activeClass = 'anchor__link--active'
  // set the current anchor to check against
  let currentAnchor = null

  // if nothing has been set yet, set the default as the first
  if (!currentAnchor) {
    currentAnchor = headings[0].id
    anchorList[0].classList.add(activeClass)
  }

  // console.log(anchorList[0])

  for (heading of headings) {
    const { y: headingY } = heading.getBoundingClientRect()
    const offsetPadding = 50
    const withinHitArea = headingY < window.innerHeight * 0.25 && headingY < window.scrollY + offsetPadding

    if (withinHitArea) {
      // clear all the active classes
      anchorList.forEach(anchor => anchor.classList.remove(activeClass))

      // re-apply the class to the corresponding link
      const activeAnchor = anchorList.find(anchor => anchor.dataset.anchor.includes(heading.id))
      activeAnchor.classList.add(activeClass)

      // update the current anchor
      currentAnchor = heading.id
    }
  }
}

window.addEventListener('DOMContentLoaded', () => {
  const pageAnchorNav = document.querySelector('.anchor__block')
  if (pageAnchorNav) initAnchors(pageAnchorNav)
})
