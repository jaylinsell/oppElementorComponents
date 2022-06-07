import initAnchors from './anchor-nav'
import applyPlaylistUpdates from './video-playlist'

window.addEventListener('DOMContentLoaded', () => {
  // Check if page has an Anchor Nav (On this page block)
  const pageAnchorNav = document.querySelector('.anchor__block')
  if (pageAnchorNav) initAnchors(pageAnchorNav)

  // set a loading state to all video playlists until the applyPlaylistUpdates func is called
  if (document.querySelector('.elementor-widget-video-playlist')) applyPlaylistUpdates()
})

// window.onload = () => {
//   // For the videos, we need to wait until the elementor JS has also loaded, not just the dom elements, so we use the onload func instead
// }
