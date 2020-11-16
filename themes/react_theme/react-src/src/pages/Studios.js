import React, {Component} from 'react';
import './style/component.css'
import CalendarSlot from "../components/CalendarSlot";
import moment from 'moment';
import {bookingSchedule, getAllDiscounts, getAllSchedule, userRegister} from '../services/ScheduleService';
import {chain, isEmpty, isEqual} from 'lodash';
import Cart from "../components/Cart";
import UserForm from "../components/UserForm";
import InstaGallery from "../components/InstaGallery";
import Swal from 'sweetalert2';
import '../../node_modules/animate.css';
import {getAllStudios} from "../services/RoomService";
import "react-loader-spinner/dist/loader/css/react-spinner-loader.css";
import CustomLoader from "../components/CustomLoader";


const initialSchedules = [
    {
        "id": "2",
        "studio_id": "1",
        "booking_id": "1",
        "type": "full",
        "slot": "2020-11-19 11:00:00",
        "created_at": "2020-11-12 00:00:00"
    }, {
        "id": "3",
        "studio_id": "1",
        "booking_id": "1",
        "type": "full",
        "slot": "2020-11-19 12:00:00",
        "created_at": "2020-11-12 00:00:00"
    }, {
        "id": "4",
        "studio_id": "1",
        "booking_id": "1",
        "type": "full",
        "slot": "2020-11-19 13:00:00",
        "created_at": "2020-11-12 00:00:00"
    }, {
        "id": "5",
        "studio_id": "1",
        "booking_id": "1",
        "type": "full",
        "slot": "2020-11-19 01:00:00",
        "created_at": "2020-11-12 00:00:00"
    }, {
        "id": "6",
        "studio_id": "1",
        "booking_id": "1",
        "type": "full",
        "slot": "2020-11-19 14:00:00",
        "created_at": "2020-11-12 00:00:00"
    }, {
        "id": "7",
        "studio_id": "1",
        "booking_id": "1",
        "type": "full",
        "slot": "2020-11-19 18:00:00",
        "created_at": "2020-11-12 00:00:00"
    }]

class Studios extends Component {

    constructor(props) {
        super(props);
        this.state = {
            header: [],
            timeSchedule: [],
            bookedSchedule: [],
            cartHeader: ['#', 'Date', 'Room', 'Time Slot', 'Price', 'Action'],
            isOpenForm: false,
            instaFeed: [],
            date: moment(),
            studios: [],
            studio: {
                "id": "1",
                "name": "willow",
                "status": "active",
                "type": "studio",
                "max_reservation": "1",
                "tax": "13",
                "price": "95",
                "created_at": "2020-11-11 06:00:00"
            },
            busySlots: [],
            isLoading: false,
            holiday: [],
            openClose: [],
            locallyAddedSlots: [],
            allDiscounts: []
        }
    }

    componentDidMount = async () => {
        const {date, studio} = this.state;
        this.setState({isLoading: true})
        try {

        } catch (err) {
        }
        const roomsStudios = await getAllStudios(1);
        const allDiscounts = await getAllDiscounts();
        this.weekFormat(moment(date).format('YYYY-MM-DD'));
        this.setState(state => {
            return {studios: roomsStudios, allDiscounts: allDiscounts}
        })
    }

    renderDiscount = (length, studio_id) => {
        const {allDiscounts} = this.state;
        const dis = allDiscounts.filter(item => (item.studio_id === studio_id && item.no_of_slot === length.toString()));
        console.log(length.toString(), studio_id, dis)
        if (isEmpty(dis[0])) return 1; else return dis[0].discount;
    }

    weekFormat = date => {
        let weekData = [];
        for (let i = 0; i < 7; i++) {
            weekData.push(moment(date).add(i, 'day').format('YYYY-MM-DD'))
        }
        this.setState(state => {
            return {header: weekData}
        }, () => this.dataWithTime())
    }

    changeDate = date => {
        this.setState({date: date, isLoading: true});
        this.weekFormat(moment(date).format('YYYY-MM-DD'));
    }

    dataWithTime = async () => {
        const {header, studio, locallyAddedSlots} = this.state;
        let dateWithTime = [];
        for (let i = 0; i < 12; i++) {
            const row = header.map((item, index) => ({
                dateWithTime: moment(item).add(i + 8, 'hour').format('YYYY-MM-DD HH:mm:ss'),
                status: 'available',
                studio_name: studio.name,
                studio_id: studio.id,
                tax: studio.tax,
                price: studio.price
            }));
            dateWithTime.push(row);
        }
        let slots = await getAllSchedule(studio.id);
        locallyAddedSlots.forEach(localSlots => {
            slots.push(localSlots);
        })
        this.setState(state => {
            return {
                timeSchedule: dateWithTime,
                busySlots: slots
            }
        }, () => this.bookedSlotTimeMapping());
    }

    bookedSlotTimeMapping = async () => {
        let {timeSchedule, busySlots, locallyAddedSlots, studio} = this.state;
        let newColSchedule = [];
        if (locallyAddedSlots.length > 0) {
            locallyAddedSlots.forEach(localSlots => {
                busySlots.forEach(slot => {
                    timeSchedule.forEach(schedule => {
                        const XY = schedule.map((item, i) => ({
                            ...item,
                            date: moment(item.dateWithTime).format('YYYY-MM-DD'),
                            status: (isEqual(item.studio_id, localSlots.studio_id) && isEqual(localSlots.slot, item.dateWithTime)) ? 'booking' :
                                (isEqual(slot.slot, item.dateWithTime) &&
                                    item.status !== 'booked' &&
                                    item.status !== 'booking' &&
                                    isEqual(slot.studio_id, studio.id)) ? 'booked' : item.status
                        }));
                        newColSchedule.push(XY);
                    });
                    timeSchedule = newColSchedule;
                    newColSchedule = [];
                });
            })
        } else {
            busySlots.forEach(slot => {
                timeSchedule.forEach(schedule => {
                    const XY = schedule.map((item, i) => ({
                        ...item,
                        date: moment(item.dateWithTime).format('YYYY-MM-DD'),
                        status: (isEqual(slot.slot, item.dateWithTime) && item.status !== 'booked') ? 'booked' : item.status
                    }));
                    newColSchedule.push(XY);
                });
                timeSchedule = newColSchedule;
                newColSchedule = [];
            });
        }


        await this.setState(state => {
            return {timeSchedule: timeSchedule, isLoading: false}
        });
    }


    addSchedule = date => {
        this.setState({isLoading: true})
        const {timeSchedule, studio, studios, locallyAddedSlots} = this.state;
        let dateWithTime = [];
        let localSlots = [];
        //add to local which slot booked.
        localSlots = locallyAddedSlots;
        localSlots.push({studio_id: studio.id, slot: date.dateWithTime});
        //reserved slot from calendar
        for (let i = 0; i < 12; i++) {
            const row = timeSchedule[i].map((item, index) => ({
                ...item,
                dateWithTime: item.dateWithTime,
                status: (item.status === 'available') ? ((item.dateWithTime === date.dateWithTime) ? 'booking' : item.status) : item.status
            }));
            dateWithTime.push(row);
        }
        const lData = localSlots.map((item, index) => ({
            ...item,
            date: moment(item.slot).format('YYYY-MM-DD'),
            studio: studios.filter(std => std.id === item.studio_id),
        }));
        //first group by studio
        const groupByStudios = chain(lData).groupBy('studio_id').map((value, key) => ({
            studio_id: key,
            data: value
        })).value();
        //second group by date
        let groupByDate = [];
        groupByStudios.forEach((stuGroup) => {
            const dateGroup = chain(stuGroup.data).groupBy('date').map((value, key) => ({
                date: key,
                data: value
            })).value();
            groupByDate.push(dateGroup);
        })

        Swal.fire({
            toast: true,
            position: 'top',
            icon: 'success',
            title: `Added ${moment(date.dateWithTime).format('YYYY-MM-DD HH:mm:A')} slot to cart.`,
            showClass: {
                popup: 'animate__animated animate__fadeInDown',
                // icon: '',

            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp',
            },
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false,
            width: 'auto',
            padding: '14px',

        });

        this.setState({
            timeSchedule: dateWithTime,
            bookedSchedule: groupByDate,
            locallyAddedSlots: localSlots,
            isLoading: false
        })
    }


    removeBookingSchedule = (date, studio_id) => {
        this.setState({isLoading: true})
        const {timeSchedule, locallyAddedSlots, studios, studio} = this.state;
        let dateWithTime = [];
        let localSlots = [];
        //removed to local which slot booked.
        console.log(locallyAddedSlots);
        localSlots = locallyAddedSlots.filter(slot => !isEqual(slot, {studio_id: studio_id, slot: date}));
        console.log(localSlots);

        for (let i = 0; i < 12; i++) {
            const row = timeSchedule[i].map((item, index) => ({
                ...item,
                dateWithTime: item.dateWithTime,
                status: (item.status === 'booking') ? ((item.dateWithTime === date) ? 'available' : item.status) : item.status
            }));
            dateWithTime.push(row);
        }

        //remove from local

        const lData = localSlots.map((item) => ({
            ...item,
            date: moment(item.slot).format('YYYY-MM-DD'),
            studio: studios.filter(std => std.id === item.studio_id),
        }));
        //first group by studio
        const groupByStudios = chain(lData).groupBy('studio_id').map((value, key) => ({
            studio_id: key,
            data: value
        })).value();
        //second group by date
        let groupByDate = [];
        groupByStudios.forEach((stuGroup) => {
            const dateGroup = chain(stuGroup.data).groupBy('date').map((value, key) => ({
                date: key,
                data: value
            })).value();
            groupByDate.push(dateGroup);
        })
        this.setState({
            timeSchedule: dateWithTime,
            bookedSchedule: groupByDate,
            locallyAddedSlots: localSlots,
            isLoading: false
        });
    }

    goToFinalStep = () => {
        this.setState({isOpenForm: true})
    }

    submitForm = async data => {
        const {bookedSchedule} = this.state;
        let schedule = [];
        bookedSchedule.forEach((scheduleData, i) => {
            scheduleData.data.forEach(item => {
                schedule.push(item.dateWithTime);
            });
        })
        try {
            await userRegister(data);
            let promises = [];
            if ((data.name && !isEmpty(schedule))) {
                const createPromises = schedule.map(async entry => {
                    return await bookingSchedule({schedule: entry, name: data.name});
                });
                promises = [...promises, ...createPromises];
            }
            await Promise.all(promises);
        } catch (e) {

        }

    }

    onChangeStudio = $event => {
        this.setState({isLoading: true})
        const {studios, date} = this.state;
        const studio = studios.filter(studio => studio.id === $event.target.value);
        //call schedule api too
        this.setState(state => {
            return {studio: studio[0]}
        }, () => this.weekFormat(moment(date).format('YYYY-MM-DD')));
    }

    render() {
        const {
            header,
            timeSchedule,
            bookedSchedule,
            cartHeader,
            isOpenForm,
            instaFeed,
            date,
            studios,
            studio,
            isLoading
        } = this.state
        return (
            <div className="container">
                {isLoading && (
                    <CustomLoader isNoteOpen={true}/>
                )}

                <div className="booking-steps-wrapper">
                    <div className="container">
                        <div className="row">
                            <div className=" col-md-4">
                                <div className="booking-step-wrapper date-time-step  active">
                                    <div className="icon"></div>
                                    <div className="text">
                                        <div className="big">Step 01</div>
                                        <div className="small">Date &amp; Start Time</div>
                                    </div>
                                </div>
                            </div>
                            <div className=" col-md-4">
                                <div className="booking-step-wrapper details-step">
                                    <div className="icon"></div>
                                    <div className="text">
                                        <div className="big">Step 02</div>
                                        <div className="small">Details</div>
                                    </div>
                                </div>
                            </div>
                            <div className=" col-md-4">
                                <div className="booking-step-wrapper payment-step">
                                    <div className="icon"></div>
                                    <div className="text">
                                        <div className="big">Step 03</div>
                                        <div className="small">Payment</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!isEmpty(bookedSchedule) && !isOpenForm && (
                    <Cart
                        header={cartHeader}
                        data={bookedSchedule}
                        getDiscount={(length, studio_id) => this.renderDiscount(length, studio_id)}
                        goToFinalStep={() => this.goToFinalStep()}
                        removeTimeSlot={(date, studio_id) => this.removeBookingSchedule(date, studio_id)}
                    >
                    </Cart>
                )}
                {!isOpenForm && (
                    <CalendarSlot header={header}
                                  studios={studios}
                                  selectedStudio={studio}
                                  timeSchedule={timeSchedule}
                                  onChangeStudio={(data) => this.onChangeStudio(data)}
                                  changeDate={(date) => this.changeDate(date)}
                                  currentDate={moment(date).format('YYYY-MM-DD')}
                                  removeBookingSchedule={(date, studio_id) => this.removeBookingSchedule(date, studio_id)}
                                  addSchedule={(date) => this.addSchedule(date)}></CalendarSlot>
                )}

                {isOpenForm && (
                    <UserForm getFormValue={(data) => this.submitForm(data)}></UserForm>
                )}
                {!isEmpty(instaFeed) && (
                    <InstaGallery instaFeed={instaFeed.data}></InstaGallery>
                )}
            </div>
        );
    }
}

//{
//
//     "email": "vipi@gFromPostman",
//     "photographer_name": "vipi",
//     "name": "newUser",
//     "shoot_type": "shoot_type JSON body passed.",
//     "note": "note FromPostman body passed."
//
// }

export default Studios;
