<template>
  <div class="relative" :class="`colorMultiStatusDisplay colorMultiStatusIndex text-${field.textAlign}`" :style="`line-height: ${field.iconSize}px; width: ${field.width};`">
      <div v-for="(oneItem, key) in dataset" class="inline-block" >
        <div class="colorMultiStatusIcon"
             v-on:mouseenter="mouseenter($event, oneItem.key, oneItem.oneValue)"
             v-on:mousemove.self="mousemove($event)"
             v-on:mouseleave="mouseleave()"
             v-on:mousedown="mousedown($event, oneItem.key, oneItem.oneValue)"
        >
          <span class="inline-block" style="pointer-events:none;" :style="`background-color: ${oneItem.color}; margin: ${field.iconSpacing}px; width: ${field.iconSize}px; height: ${field.iconSize}px;`"></span>
        </div>
      </div>
      <div v-if="field.showTooltips && tooltip" class="colorMultiStatusTooltip absolute 10" :style="`left: ${pos.left}px; top: ${pos.top}px`">
        <div class="w-32 p-2 -mt-1 text-sm leading-tight transform -translate-x-1/2 -translate-y-full bg-80 bg-white rounded-lg shadow-lg">
          <span v-if="!useArray" class="tooltipKey" style="pointer-events:none;">{{tooltipKey}}:</span> <b>{{tooltipName}}</b>
        </div>
      </div>
  </div>
</template>

<script>

export default {
  props: ['resourceName', 'field', 'setDefaultParams', 'prepareDataset', 'tooltip', 'pos', 'tooltipName', 'tooltipKey', 'useArray'],
  methods: {
    mousedown: function (ev, textKey, textName) {
      this.tooltip = !this.tooltip;
      this.tooltipKey = textKey;
      this.tooltipName = textName;
      this.pos = {
        left: ev.layerX + 15,
        top: ev.layerY + 15,
      };
    },
    mouseenter: function(ev, textKey, textName) {
      this.tooltip = true;
      this.tooltipKey = textKey;
      this.tooltipName = textName;
      this.pos = {
        left: ev.layerX + 15,
        top: ev.layerY + 15,
      };
    },
    mousemove: function(ev) {
      this.pos = {
        left: ev.layerX + 15,
        top: ev.layerY + 15,
      };
    },
    mouseleave: function() {
      this.tooltip = false;
    }
  },
  created() {

    // set default params
    this.field.value = this.field.value || {}
    this.setDefaultParams(this.field);
    this.tooltip = false;
    this.pos = {
      left:0,
      top:0,
    };
    // prepare dataset for rendering
    this.useArray = Array.isArray(this.field.value);
    this.dataset = this.prepareDataset(this.field);
  },
}

</script>
