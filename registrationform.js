( function() {
  const app = new Vue({
    el: document.querySelector('#mount'),
    template:
    '<form class="registration-form" id="registration-form" @submit.prevent="validateData">' +
      '<div class="registration-form">' +
        '<label for="firstname">Etunimi</label>' +
        '<input type="text" name="firstname" v-model="postdata.firstname">' +
      '</div>' +
      '<div class="registration-form">' +
        '<label for="lastname">Sukunimi</label>' +
        '<input type="text" name="lastname" v-model="postdata.lastname">' +
      '</div>' +
      '<div class="registration-form">' +
        '<label for="email">Sähköpostiosoite</label>' +
        '<input type="email" name="email" v-model="postdata.email">' +
      '</div>' +
      '<div class="registration-form">' +
        '<label for="age">Ikä</label>' +
        '<input type="text" name="age" v-model="postdata.age">' +
      '</div>' +
      '<div class="registration-form">' +
        '<input type="submit" value="Lähetä">' +
      '</div>' +
    '</form>',
    methods: {
      validateData() {
        var url = '/wp-json/vueplugin/v1/validate-form-data';
        const requestOptions = {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(this.postdata)
        };
        fetch(url, requestOptions)
        .then(response => response.json())
        .then((data)=>{
          this.resultdata = data;
          this.printResponse();
        });
      },
      printResponse() {
        let alertMessage = 'Virhe tiedoissa:\n';
        if (this.resultdata.errors) {
          this.resultdata.errors.forEach((value, index) => {
            alertMessage += value + '\n';
          });
          alert(alertMessage);
        } else {
          const resultDiv = document.createElement('div');
          const resultMessage = document.createTextNode('Tiedot tallennettu onnistuneesti!');
          resultDiv.appendChild(resultMessage);
          resultDiv.classList.add('success-message');

          const element = document.getElementById('registration-form');
          element.appendChild(resultDiv);

          setTimeout(function() {
            window.location.reload();
          }, 5000);
        }
      }
    },
    data: {
      postdata: {
        firstname: '',
        lastname: '',
        email: '',
        age: ''
      },
      resultdata: []
    }
  });
})();