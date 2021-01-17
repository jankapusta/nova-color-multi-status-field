<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <table v-if="!field.readonly" class="colorMultiStatusForm table w-full">
        <tr v-for="(rowData, index) in value">
          <td>
            <input v-if="!useArray" class="form-control form-input form-input-bordered"
                   v-model="value[index]['key']"
                   required
            >
          </td>
          <td>
            <input class="form-control form-input form-input-bordered"
                   v-model="value[index]['oneValue']"
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
      <div v-if="field.readonly" class="colorMultiStatusDisplay colorMultiStatusForm" :class="`text-${field.textAlign}`" :style="`line-height: ${field.iconSize}px; width: ${field.width};`">
        <div v-for="(oneItem, key) in value" x-data="{ tooltip: false }" class="relative inline-block" >
          <div class="colorMultiStatusIcon" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false">
            <span class="inline-block" :style="`background-color: ${oneItem.color}; margin: ${field.iconSpacing}px; width: ${field.iconSize}px; height: ${field.iconSize}px;`"></span>
          </div>
          <div v-if="field.showTooltips" class="colorMultiStatusTooltip absolute 10" x-cloak x-show.transition.origin.top="tooltip">
            <div class="w-32 p-2 -mt-1 text-sm leading-tight transform -translate-x-1/2 -translate-y-full bg-80 bg-white rounded-lg shadow-lg">
              <span v-if="!useArray" class="tooltipKey">{{oneItem.key}}:</span> {{oneItem.oneValue}}
            </div>
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

  props: ['resourceName', 'resourceId', 'field', 'setDefaultParams', 'prepareDataset'],

  created() {
    this.field.value = this.field.value || {}
    if (this.field.readonly) {
      this.setDefaultParams(this.field);
      if (this.field.showTooltips) {
        require('alpinejs');
      }
    }
  },

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      // prepare dataset for rendering
      this.useArray = Array.isArray(this.field.value);
      this.value = this.prepareDataset(this.field);
    },

    addValue() {
      this.value.push({
        key: 'new-key',
        oneValue: '',
      });
    },

    removeValue(index) {
      this.value.splice(index, 1);
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      let dataset;
      if (this.useArray) {
        dataset = this.value.map((one) => {
          return one['oneValue'];
        });
      } else {
        dataset = {};
        this.value.forEach(one => {
          dataset[one['key']] = one['oneValue'];
        });
      }
      formData.append(
          this.field.attribute,
          JSON.stringify(dataset)
      );
    },
  },
}
</script>
