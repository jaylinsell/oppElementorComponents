---
inject: true
to: src/assets/scss/styles.scss
before: "additional <%= folder %>"
---
@import '<%= folder %>/<%= h.changeCase.kebab(name) %>';