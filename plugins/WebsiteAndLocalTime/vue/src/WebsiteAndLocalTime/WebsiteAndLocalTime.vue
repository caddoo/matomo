<!--
  Matomo - free/libre analytics platform
  @link https://matomo.org
  @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
-->

<template>
  <div v-if="clientInSameTimezoneAsWebsite">
    <h2 class="center-align" style="padding-bottom:40px;">
      {{ websiteDateTime }}
    </h2>
  </div>
  <div v-else>
    <p>
      <strong>Website time: </strong>
      {{ websiteDateTime }}
    </p>
    <p>
      <strong>Local time: </strong>
      {{ localDateTime }}
    </p>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    websiteTimeZoneName: {
      type: String,
    },
  },
  data() {
    return {
      websiteDateTime: '',
      localDateTime: '',
      localTimeZoneName: '',
      interval: 0,
    };
  },
  mounted() {
    this.interval = setInterval(() => {
      this.updateTimes();
    }, 1000);

    this.localTimeZoneName = Intl.DateTimeFormat().resolvedOptions().timeZone;
    this.updateTimes();
  },
  computed: {
    clientInSameTimezoneAsWebsite() {
      return this.localTimeZoneName === this.websiteTimeZoneName;
    },
  },
  methods: {
    updateTimes() {
      const serverTimeFormat: Intl.DateTimeFormatOptions = {
        month: 'numeric',
        year: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true,
        timeZone: this.websiteTimeZoneName,
      };

      const serverTimeFormatter = new Intl.DateTimeFormat([], serverTimeFormat);
      this.websiteDateTime = (serverTimeFormatter.format(new Date()));

      const localTimeFormat: Intl.DateTimeFormatOptions = {
        month: 'numeric',
        year: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true,
      };
      const localTimeFormatter = new Intl.DateTimeFormat([], localTimeFormat);
      this.localDateTime = localTimeFormatter.format(new Date());
    },
  },
});
</script>
