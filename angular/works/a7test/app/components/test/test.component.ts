import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-test',
  templateUrl: './test.component.html',
  styleUrls: ['./test.component.css']
})
export class TestComponent implements OnInit {
  constructor() { }

  name = 'Bablu';
  mobile = '01730910539';
  email: string;
  age: number;
  gender: any;
  // object type
  presentAddress: {
    street: string,
    city: string,
    state: string
  };
  permanentAddress: PerAddress;
  // array of string type
  hobbies: string[];

  ngOnInit() {
    this.email = 'bablukpik@gmail.com';
    this.age = 30;
    this.gender = 'Male';
    this.presentAddress = {
      street: '91/c',
      city: 'Rampura',
      state: 'Dhaka'
    };
    this.permanentAddress = {
      vill: 'Krishnapur Choruwa Para',
      thana: 'Kurigram',
      district: 'Kurigram',
      division: 'Rangpur'
    };
    this.hobbies = ['Write Code', 'Watch Movies', 'Listen to Music'];
  }

  addNewHobby() {
      this.hobbies.push('Add New Hobby');
  }
  addNewHobbyByForm(hobby) {
      this.hobbies.unshift(hobby);
      return false;
  }
  // delete by item with index
  /*deleteHobby(item, item_index) {
    const foundHobby = this.hobbies.indexOf(item);
    if (foundHobby !== -1) {
      this.hobbies.splice(item_index, 1);
    }
  }*/
  // delete by item
  deleteHobby(item, item_index) {
    const foundHobby = this.hobbies.indexOf(item);
    if (foundHobby !== -1) {
      this.hobbies.splice(item_index, 1);
    }
  }

}

// declaration
interface PerAddress {
  vill: string;
  thana: string;
  district: string;
  division: string;
}

