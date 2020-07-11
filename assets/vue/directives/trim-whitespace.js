export default {
bind: function trimEmptyTextNodes (el) {
    for (let node of el.childNodes) {
      if (node.nodeType === Node.TEXT_NODE && node.data.trim() === '') {
        node.remove()
      }
    }
  }
}

