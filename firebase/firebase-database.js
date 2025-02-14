const db = firebase.firestore();
db.collection("users").get().then(snapshot => {
    snapshot.forEach(doc => {
        console.log(doc.data());
    });
});
