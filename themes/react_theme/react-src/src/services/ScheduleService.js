import API from '../utils/api';

export const getAllSchedule = async (id) => {
    let schedule = await API.get(`http://localhost/wordpress/index.php/wp-json/std/slots/${id}`);

    return schedule.data;
};

//user register
export const userRegister = async (data) => {
    let schedule = await API.post('http://localhost/wordpress/index.php/wp-json/wl/v1/std-users' , data);
    return schedule;
};

export const bookingSchedule = async (data) => {
    let schedule = await API.post('http://localhost/wordpress/index.php/wp-json/wl/v1/schedule' , data);
    return schedule;
};

export const getAllDiscounts = async () => {
    let schedule = await API.get('http://localhost/wordpress/index.php/wp-json/std/discount');
    return schedule.data;
};

//slot reserve
export const reserveSlot = async (data) => {
    try {
        let schedule = await API.post('http://localhost/wordpress/index.php/wp-json/std/slots' , data);
        return schedule.data;
    }catch (e) {
        throw e;
    }

};
//remove reserve
export const removeReservedSlot = async (data) => {
    try{
        let schedule = await API.delete('http://localhost/wordpress/index.php/wp-json/std/slots' , {data:data});
        return schedule.data;
    }catch (e) {
        throw e;
    }
};

// import axios from 'axios';
//
// export function getSchedule() {
//     return new Promise(((resolve, reject) => {
//         axios({
//             method: 'GET',
//             url: `http://localhost/wordpress/index.php/wp-json/wl/v1/latest-posts/1`,
//             data: null,
//             timeout: 60000,
//             headers: {
//                 'Content-Type': 'application/json',
//                 'Accept': 'application/json'
//             }
//         }).then((res) => {
//             resolve(res);
//         }).catch((error) => {
//             reject(error);
//         });
//     }));
// }
