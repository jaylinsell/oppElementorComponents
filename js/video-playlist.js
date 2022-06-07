const elementorWrappers = document.querySelectorAll('.elementor-widget-video-playlist')

const applyPlaylistUpdates = () => {
  // if the video is on a colour other than white, we need to add a class to control the video background colour
  for (const wrapper of elementorWrappers) {
    const parentWrapper = wrapper.closest('.elementor-section')
    const bgColor = window.getComputedStyle(parentWrapper).getPropertyValue('background-color')

    if (bgColor !== 'rgba(0, 0, 0, 0)') wrapper.classList.add('has-bg')
  }
}

export default applyPlaylistUpdates
