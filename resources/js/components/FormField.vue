<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <table v-if="!field.readonly" class="colorMultiStatusForm table w-full">
        <tr v-for="(rowData, index) in dataset">
          <td>
            <input v-if="!useArray" class="form-control form-input form-input-bordered"
                   v-model="dataset[index]['key']"
                   required
            >
          </td>
          <td>
            <input class="form-control form-input form-input-bordered"
                   v-model="dataset[index]['oneValue']"
                   required
            >
          </td>
          <td>
            <button class="btn btn-default btn-danger"
                    @click.prevent="removeValue(index)">-
            </button>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button class="btn btn-default btn-primary" @click.prevent="addValue()">+
            </button>
          </td>
        </tr>
      </table>
      <div v-if="field.readonly" class="relative colorMultiStatusDisplay colorMultiStatusForm" :class="`text-${field.textAlign}`" :style="`line-height: ${field.iconSize}px; width: ${field.width};`">
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
  </default-field>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],
  props: ['resourceName', 'resourceId', 'field', 'setDefaultParams', 'prepareDataset', 'tooltip', 'pos', 'tooltipName', 'tooltipKey', 'useArray'],
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
    },
    /*
     * Set the initial, internal dataset for the field.
     */
    setInitialValue() {
      // prepare dataset for rendering
      this.useArray = Array.isArray(this.field.value);
      this.dataset = this.prepareDataset(this.field);
    },

    addValue() {
      this.dataset.push({
        key: 'new-key',
        oneValue: '',
      });
    },

    removeValue(index) {
      this.dataset.splice(index, 1);
    },

    /**
     * Fill the given FormData object with the field's internal dataset.
     */
    fill(formData) {
      let dataset;
      if (this.useArray) {
        dataset = this.dataset.map((one) => {
          return one['oneValue'];
        });
      } else {
        dataset = {};
        this.dataset.forEach(one => {
          dataset[one['key']] = one['oneValue'];
        });
      }
      formData.append(
          this.field.attribute,
          JSON.stringify(dataset)
      );
    },
  },
  created() {
    this.field.value = this.field.value || {}
    if (this.field.readonly) {
      this.setDefaultParams(this.field);
      this.tooltip = false;
      this.pos = {
        left:0,
        top:0,
      };
    }
  },
}
</script>
