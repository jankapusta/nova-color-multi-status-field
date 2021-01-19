<template>
  <div :class="`colorMultiStatusDisplay colorMultiStatusIndex text-${field.textAlign}`" :style="`line-height: ${field.iconSize}px; width: ${field.width};`">
      <div v-for="(oneItem, key) in dataset" x-data="{ tooltip: false }" class="relative inline-block" >
        <div class="colorMultiStatusIcon" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false">
          <span class="inline-block" :style="`background-color: ${oneItem.color}; margin: ${field.iconSpacing}px; width: ${field.iconSize}px; height: ${field.iconSize}px;`"></span>
        </div>
        <div v-if="field.showTooltips" class="colorMultiStatusTooltip absolute 10" x-cloak x-show.transition.origin.top="tooltip" style="pointer-events:none;">
          <div class="w-32 p-2 -mt-1 text-sm leading-tight transform -translate-x-1/2 -translate-y-full bg-80 bg-white rounded-lg shadow-lg">
            <span v-if="!useArray" class="tooltipKey">{{oneItem.key}}:</span> {{oneItem.oneValue}}
          </div>
        </div>
      </div>
  </div>
</template>

<script>

export default {
  props: ['resourceName', 'field', 'setDefaultParams', 'prepareDataset'],

  created() {

    // set default params
    this.field.value = this.field.value || {}
    this.setDefaultParams(this.field);

    // prepare dataset for rendering
    this.useArray = Array.isArray(this.field.value);
    this.dataset = this.prepareDataset(this.field);

    if (this.field.showTooltips) {
      require('alpinejs');
    }
  },
}

</script>
