import { auth } from "./firebase-config.js";
import { 
  createUserWithEmailAndPassword, 
  signInWithEmailAndPassword, 
  signInWithPopup, 
  GoogleAuthProvider, 
  signOut, 
  RecaptchaVerifier, 
  signInWithPhoneNumber 
} from "firebase/auth";

// Google Sign-In Provider
const googleProvider = new GoogleAuthProvider();

/** 
 * Register user with Email and Password
 */
async function registerWithEmail(email, password) {
  try {
    const userCredential = await createUserWithEmailAndPassword(auth, email, password);
    console.log("User Registered:", userCredential.user);
    return userCredential.user;
  } catch (error) {
    console.error("Registration Error:", error.message);
    alert(error.message);
  }
}

/** 
 * Login with Email and Password
 */
async function loginWithEmail(email, password) {
  try {
    const userCredential = await signInWithEmailAndPassword(auth, email, password);
    console.log("User Logged In:", userCredential.user);
    return userCredential.user;
  } catch (error) {
    console.error("Login Error:", error.message);
    alert(error.message);
  }
}

/** 
 * Login with Google
 */
async function loginWithGoogle() {
  try {
    const result = await signInWithPopup(auth, googleProvider);
    console.log("Google Login Successful:", result.user);
    return result.user;
  } catch (error) {
    console.error("Google Login Error:", error.message);
    alert(error.message);
  }
}

/** 
 * Logout user
 */
async function logout() {
  try {
    await signOut(auth);
    console.log("User Logged Out");
  } catch (error) {
    console.error("Logout Error:", error.message);
  }
}

/** 
 * Setup Phone Authentication
 */
function setupRecaptcha() {
  window.recaptchaVerifier = new RecaptchaVerifier(auth, "recaptcha-container", {
    size: "invisible",
  });
}

/** 
 * Send OTP to Phone Number
 */
async function sendOTP(phoneNumber) {
  setupRecaptcha();
  try {
    const confirmationResult = await signInWithPhoneNumber(auth, phoneNumber, window.recaptchaVerifier);
    window.confirmationResult = confirmationResult;
    console.log("OTP Sent to:", phoneNumber);
    return confirmationResult;
  } catch (error) {
    console.error("OTP Error:", error.message);
    alert(error.message);
  }
}

/** 
 * Verify OTP Code
 */
async function verifyOTP(otpCode) {
  try {
    const result = await window.confirmationResult.confirm(otpCode);
    console.log("Phone Auth Successful:", result.user);
    return result.user;
  } catch (error) {
    console.error("OTP Verification Error:", error.message);
    alert(error.message);
  }
}

// Export functions for use in other files
export { registerWithEmail, loginWithEmail, loginWithGoogle, logout, sendOTP, verifyOTP };

