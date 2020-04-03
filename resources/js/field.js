Nova.booting((Vue, router, store) => {
  Vue.component('index-exact-online-field', require('./components/IndexField'))
  Vue.component('detail-exact-online-field', require('./components/DetailField'))
  Vue.component('form-exact-online-field', require('./components/FormField'))
})
