Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'exact-online',
      path: '/exact-online',
      component: require('./components/Tool'),
    },
  ])
})
