if(localStorage.getItem('tokenGNOG') !== null)
    document.querySelector('meta[name="csrf-token"]').content = localStorage.getItem('tokenGNOG').split('.')[2];