
const domElements = {}

const initAnchors = (_anchorNav) => {
  domElements.anchorNav = _anchorNav
  const anchors = domElements.anchorNav.querySelectorAll('a')

  updateAnchorAccessability(anchors)

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

const handleScroll = _anchors => {
  updateActiveAnchor(_anchors)
  updateAnchorPositionValue()
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
    const withinHitArea = headingY < window.innerHeight * 0.5 && headingY < window.scrollY + offsetPadding

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

const updateAnchorPositionValue = () => {
  const { anchorNav } = domElements
  const { y } = anchorNav.getBoundingClientRect()
  const offsetPadding = 100
  const isInScreen = y < window.innerHeight

  if (isInScreen) {
    const pos = y < offsetPadding ? `${Math.abs(y) + offsetPadding}` : 0
    anchorNav.style.setProperty('--translatePosition', `${pos}px`)
  }
}


window.addEventListener('DOMContentLoaded', () => {
  const pageAnchorNav = document.querySelector('.anchor__block')
  if (pageAnchorNav) initAnchors(pageAnchorNav)
})
