
Vue.component('manage-posts', {
  template: '#manage-template',
  data: function() {
    return {
      posts: [
        'This is my first post about Vue JS',
        'This is my Second post about Vue JS',
        'This is my third post about Vue JS'
      ]
    }
  }
});

Vue.component('create-post', {
  template: '#create-template'
});

new Vue({
  el: '#app',
  data: {
    currentView: 'manage-posts'
  },

  watch:{
  	currentView: function(query){
  		console.log(query);
  	}
  }
});