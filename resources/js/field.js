Nova.booting((Vue, router, store) => {

  Vue.mixin({
    methods: {
      setDefaultParams: function (field) {
        field.colorMap = field.colorMap || {}
        field.width = field.width ? field.width + 'px' : 'auto';
        field.iconSize = field.iconSize || 4;
        field.iconSpacing = field.iconSpacing || 1;
        if (field.showTooltips == undefined) {
          field.showTooltips = true;
        }
      },
      prepareDataset: function (field) {
        return Object.keys(field.value)
            .map((index) => {
              return {
                key: index,
                oneValue: field.value[index],
                color: this.calculateColor(field.colorMap, field.value[index])
              }
            });
      },
      calculateColor: function (colorMap, val) {
        if (!colorMap || Object.keys(colorMap).length === 0) {
          return val ? '#21b978' : '#e74444';
        }
        if (colorMap[val] !== undefined) {
          return colorMap[val];
        }
        let oneColor;
        for (const i in colorMap) {
          oneColor = colorMap[i];
          if (val < i) {
            return oneColor;
          }
        }
        return oneColor;
      },
    },
  });
  Vue.component('index-nova-color-multi-status-field', require('./components/IndexField'))
  Vue.component('detail-nova-color-multi-status-field', require('./components/DetailField'))
  Vue.component('form-nova-color-multi-status-field', require('./components/FormField'))
})

