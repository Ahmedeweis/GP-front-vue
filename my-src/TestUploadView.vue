<!-- eslint-disable vuejs-accessibility/form-control-has-label -->
<template>
  <div>
    <h1>File API Example</h1>
    <input type="text" v-model="filePath" placeholder="Enter file path">
    <button @click="fetchData">Fetch Data</button>

    <h2>Response:</h2>
    <p>{{ responseBody }}</p>

    <h2>Author:</h2>
    <p>{{ author }}</p>
  </div>
</template>

<script>
export default {
  name: 'TestUploadView',
  data() {
    return {
      filePath: '',
      responseBody: '',
      author: '',
    };
  },
  methods: {
    fetchData() {
      fetch(`http://localhost:8888/author/readPdf?filePath=${this.filePath}`)
        .then((response) => response.json())
        .then((data) => {
          this.responseBody = data.body;
          this.identifyAuthor();
        })
        .catch((error) => {
          console.error(error);
        });
    },
    identifyAuthor() {
      fetch(`http://localhost:8888/author/identifyAuthor?article=${this.responseBody}`)
        .then((response) => response.json())
        .then((data) => {
          this.author = data.author;
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
