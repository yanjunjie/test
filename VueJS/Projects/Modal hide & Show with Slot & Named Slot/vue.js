
		Vue.component('btn',{
			template:`
				<button @click="launchModal" type="button" class="btn btn-info btn-lg">Open Modal</button>
			`,
			methods:{
				launchModal: function(){
					this.$emit('modal-btn-clicked'); //custom event
				}
			}

		});


		Vue.component('modal',{
			template:`
			<div id="myModal" :class="activeModal" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">			        
			      	<slot name="modal_header"></slot>
			      </div>
			      <div class="modal-body">
			        <slot name="modal_body"></slot>
			      </div>
			      <div class="modal-footer">
			        <button type="button" @click="innerCloseBtn" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>

			  </div>
			</div>
			`,
			props:['activeModal'],

			methods:{
				innerCloseBtn: function(){
					this.$emit('inner-close-btn'); //custom event
				}
			}

		});


		new Vue ({
			el:'#app',
			data:{
				activeModal:'modal'
			},

			methods:{
				modalLaunched: function(){
					this.activeModal='modalopen';
				},
				closeModal: function(){
					this.activeModal='modal';
				}
			}
		});