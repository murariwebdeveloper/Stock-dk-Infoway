export default {
    functions: {

        alert(){
          alert("hello");
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            });
        },

        showSuccess(message) {
            this.$toast.success(message, {
                position: "top-right",
                timeout: 5000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: false,
                closeButton: "button",
                icon: true,
                rtl: false
            });
        },
        showError(message){
            this.$toast.error(message, {
                position: "top-right",
                timeout: 10000,
                closeOnClick: false,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: false,
                closeButton: "button",
                icon: true,
                rtl: false
            });
        },

        getFormData(data){
            let formData = new FormData();
            for (let key in data) {
                formData.append(key, data[key]);
            }
            return formData;
        },

        getShortName(sentence){
            let shortName = sentence;

            // Split the sentence into individual words
            let words = sentence.split(' ');
            if (words.length > 1) {
                // Extract the first character of each word and capitalize it
                let initials = words.map(word => word[0].toUpperCase());
                // Join the initials together to form the short name
                shortName = initials.join('.');
            }

            return shortName;
        }

    },
};
