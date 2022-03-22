<template>
  <div>
    <h1>{{ titleUppercase }}</h1>
    <ul>
      <li v-for="element in items" :key="element">
        {{ element }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "List",
  props: {
    title: {
      type: String,
      required: true,
    },
    items: {
      type: Array,
      required: true,
    },
  },
  mounted() {
    console.log(this.title);
  },
  data() {
    return {};
  },
  methods: {
    reloadData() {
      this.$inertia.reload();
    },
  },
  computed: {
    titleUppercase() {
      return this.title.toUpperCase();
    },
  },
};
</script>
