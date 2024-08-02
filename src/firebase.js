
import {createUserWithEmailAndPassword, signInWithEmailAndPassword, getAuth} from "firebase/auth";

// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyCcy7jYlKi7KvwkFWjWg-2dqlJfoNg8vPY",
  authDomain: "charnic-2f915.firebaseapp.com",
  projectId: "charnic-2f915",
  storageBucket: "charnic-2f915.appspot.com",
  messagingSenderId: "1001151763374",
  appId: "1:1001151763374:web:8532b67995feafea7a6e3f"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

export const createUser = async (email, password) => {
  return createUserWithEmailAndPassword(getAuth(app), email, password);
}

export const signInUser = async (email, password) => {
  return signInWithEmailAndPassword(getAuth(app), email, password);
}

