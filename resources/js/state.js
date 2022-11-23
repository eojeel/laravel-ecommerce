const state = {
    user: {
        token: sessionStorage.getItem('TOKEN'),
        date: {}
    },
    products: {
        loading: false,
        data: []
    }
};

export default state;
