Vue.component('signUpForm',{
	
	template:'#signUpForm-template',
	
	data(){
		return {
			password:'',
			confirmPassword:'',
			email:'',
			msg:[],
			disableSubmitButton : true,
		}
	},

	watch:{
		email(value){
			//console.log(value);
			this.eventName();
			//this.email = value;
			this.check_email(value);
		},
		password(value){
			this.eventName();
			this.password = value;
			this.checkPassword(value);
		},
		confirmPassword(value){
			this.eventName();
			this.confirmPassword = value;
			this.checkConfirmPassword(value);
		}
	},

	methods:{
		changeToTnc(){
			this.$emit('change-compo-btn','tnc');
		},

		check_email(value){
			if (/^\w+([\.-]?\ w+)*@\w+([\.-]?\ w+)*(\.\w{2,3})+$/.test(value))
			{
				this.msg['email'] = '';
			}else{
				this.msg['email'] = 'Keep Typing... We are waiting for correct Email';
			}
		},
		
		checkPassword(value){
			this.passwordLengthCheck(value);
		},
		
		checkConfirmPassword(value){
			if(this.passwordLengthCheck(value)){
				if (value == this.password) {
					this.msg['password']= '';
					this.disableSubmitButton = false;
				}else{
					this.msg['password'] = "Password does not match, please try again";
				}
			}
		},
		
		passwordLengthCheck(passwordToCheck){
			remainingChars = 6 - passwordToCheck.length;
			if (passwordToCheck.length < 6) {
				this.msg['password'] = 'Password must contain 6 characters. '+ remainingChars +' more to go...';
			}else{
				this.msg['password'] ='';
				return true;
			}
		},
		
		eventName(){
			name = event.target.name;
			console.log(name);
		},
		
		submit(){
			alert('Great you have completed this project, keep learning.')
		}
	}
});

Vue.component('tnc',{
	template:'#tnc-template',
	methods:{
		back_to_signup(){
			this.$emit('change-compo-btn','signUpForm');
		}
	}
});

new Vue({
	el:'#app',
	data:{
		currentView:'signUpForm'
	},
	methods:{
		changeComponent(newComp){
			this.currentView = newComp;
		}
	}
});