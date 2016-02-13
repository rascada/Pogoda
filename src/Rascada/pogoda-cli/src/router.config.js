import weather from './components/weather';

export default function(router) {
  router.map({
    '/': {
      component: weather,
    },
  });
  return router;
};
