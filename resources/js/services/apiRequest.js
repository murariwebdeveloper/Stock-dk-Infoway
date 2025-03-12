import ApiService from "./apiService";

const apiUrl = window.apiUrl;
const baseUrl =  window.baseUrl;

function getFormData(data){
    let formData = new FormData();
    for (let key in data) {
        if(Array.isArray(data[key])){


            data[key].forEach((element) => {

                console.log("data[key] =>", data[key]);

                console.log("element =>", element);

                for (let subKey in element) {
                    console.log("subKey =>", subKey);
                    formData.append(subKey+'[]', element[subKey]);
                }

                /*elements.forEach(function(element, index) {
                    console.log(index); // Outputs the index
                });*/

            });
        }else{
            formData.append(key, data[key]);
        }
    }
    return formData;
};

const ApiRequest = {

    /*Admin login api call start*/
    login(form){
        let resource = apiUrl+"/login";
        console.log("resource", resource);

        let formData = getFormData(form);

        return ApiService.post(resource, formData)
            .then(response => response)
            .catch(error => {
                // Handle errors
                console.warn(error, resource);
            });
    },

    fetchUser(){
        let resource = apiUrl+"/user-details";
        return ApiService.get(resource)
            .then(response => response)
            .catch(error => {
                // Handle errors
                console.warn(error, resource);
            });
    },

    logout(){
        let resource = apiUrl+"/logout";
        return ApiService.post(resource)
            .then(response => response)
            .catch(error => {
                // Handle errors
                console.warn(error, resource);
            });
    },

    deleteStore(form){
        let resource = apiUrl+"/store/delete";
        console.log("resource", resource);

        let formData = getFormData(form);

        return ApiService.post(resource, formData)
            .then(response => response)
            .catch(error => {
                // Handle errors
                console.warn(error, resource);
            });
    },

    saveStore(form){
        let resource = apiUrl;

        if(form.id){
            resource += "/store/update";
        }else{
            resource += "/store/save";
        }
        let formData = getFormData(form);
        return ApiService.post(resource, formData)
            .then(response => response)
            .catch(error => {
                // Handle errors
                console.warn(error, resource);
            });
    },

    getStoreData(resource, params){
        return ApiService.get(resource, params)
            .then(response => response)
            .catch(error => {
                // Handle errors
                console.warn(error, resource);
            });
    },

    getStores(){
        let resource = apiUrl+"/store";
        return ApiService.get(resource)
            .then(response => response)
            .catch(error => {
                // Handle errors
                console.warn(error, resource);
            });
    },





    deleteEntry(form){
        let resource = apiUrl+"/entry/delete";
        console.log("resource", resource);

        let formData = getFormData(form);

        return ApiService.post(resource, formData)
            .then(response => response)
            .catch(error => {
                // Handle errors
                console.warn(error, resource);
            });
    },

    saveEntry(form){
        let resource = apiUrl;

        if(form.id){
            resource += "/entry/update";
        }else{
            resource += "/entry/save";
        }
        let formData = getFormData(form);
        return ApiService.post(resource, formData)
            .then(response => response)
            .catch(error => {
                // Handle errors
                console.warn(error, resource);
            });
    },

    getEntryData(resource, params){
        return ApiService.get(resource, params)
            .then(response => response)
            .catch(error => {
                // Handle errors
                console.warn(error, resource);
            });
    }

};
export default ApiRequest;
