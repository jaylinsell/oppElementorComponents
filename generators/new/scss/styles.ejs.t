---
inject: true
to: scss/style.scss
before: "additional <%= folder %>"
---
@import '<%= folder %>/<%= h.changeCase.kebab(name) %>';