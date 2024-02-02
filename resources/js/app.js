/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import axios from 'axios';
import './bootstrap';

import Echo from 'laravel-echo';

const form = document.getElementById('message-form');
const inpMessage = document.getElementById('inp-message');
form.addEventListener('submit' , function(event) {
    event.preventDefault();
  const val = inpMessage.value ;
  console.log(val);
  axios.post('/chat-message' , {'message': val})
})

const channer = window.Echo.channel('public.room.enter');
channer.subscribed(() => {
console.log('sub')
}).listen('.UserEnteRoom' , (event) => {
    console.log(event);
});

