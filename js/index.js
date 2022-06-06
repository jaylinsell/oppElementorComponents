import initAnchors from './anchor-nav'

window.addEventListener('DOMContentLoaded', () => {
  const pageAnchorNav = document.querySelector('.anchor__block')
  if (pageAnchorNav) initAnchors(pageAnchorNav)
})
