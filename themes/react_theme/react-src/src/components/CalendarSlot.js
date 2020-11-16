import React from 'react';
import moment from 'moment';
import Moment from "react-moment";
import 'react-day-picker/lib/style.css';
import DatePicker from "../core/CalendarCompo";
import {isEmpty, isEqual} from "lodash";
import rightArrow from "../assets/icons/angle-right-solid.svg";
import leftArrow from "../assets/icons/angle-left-solid.svg"

const CalendarSlot = props => {
    const {header, timeSchedule, addSchedule, removeBookingSchedule, currentDate ,studios,selectedStudio ,onChangeStudio} = props;

    const onChangeDate = (day) => {
        props.changeDate(moment(day));
    }
    const goToNextWeek = () => {
        console.log(moment(currentDate).format('YYYY-MM-DD'));
        props.changeDate(moment(currentDate).add(7, 'day'));
    }
    const goToPreviousWeek = () => {
        console.log(moment(currentDate).format('YYYY-MM-DD'));
        props.changeDate(moment(currentDate).subtract(7, 'day'));
    }

    return (
        <div>
            {/*{!isEmpty(currentDate) && (*/}
            {/*    <div>{currentDate}</div>*/}
            {/*)}*/}
            <br/>
            <div className="row">
                <div className="col col-sm-4 col-md-4 col-lg-4">
                    {/*<div>*/}
                        {/*<label htmlFor="inputState">State</label>*/}
                        <select id="inputState"
                                onChange={(event)=>onChangeStudio(event)}
                                className="form-control" style={{width: '180px'}}>
                            {studios.map(studio=>{
                                return <option selected={isEqual(studio , selectedStudio)}
                                               value={studio.id}
                                >{studio.name}
                                </option>
                            })}
                        </select>
                    {/*</div>*/}

                </div>
                <div className="col col-sm-8 col-md-8 col-lg-8" >
                    <div className="row" style={{float: 'right'}}>
                        <button type="button" style={{margin: '4px'}} className="btn btn-success">Add Makeup station
                        </button>
                        <button type="button" style={{margin: '4px'}} className="btn btn-success">Go to Cart</button>
                        {/*<button type="button" style={{*/}
                        {/*    margin: '4px',*/}
                        {/*    display: (moment(currentDate).isSameOrBefore(moment().format('YYYY-MM-DD'), 'day')) ? 'none' : ''*/}
                        {/*}} onClick={goToPreviousWeek} className="btn btn-secondary">*/}

                        {/*</button>*/}
                        <img   type="button" style={{ height:'32px' , width:'32px' ,marginTop:'7px',
                            margin: '4px',
                            color:"green",
                            display: (moment(currentDate).isSameOrBefore(moment().format('YYYY-MM-DD'), 'day')) ? 'none' : ''
                        }} onClick={goToPreviousWeek}  src={leftArrow} alt={leftArrow}/>

                        <DatePicker
                            date={currentDate}
                            onChangeDate={onChangeDate}/>

                        <img onClick={goToNextWeek} style={{height:'32px' , width:'32px' ,marginTop:'7px',
                                        color:"green",
                                        margin: '4px',}} src={rightArrow} alt={rightArrow}/>

                    </div>
                </div>
            </div>

            <br/>
            <div className="table-responsive-xl">
                <table className="table table-sm">
                    <thead>
                    <tr>
                        {header.map((item, index) => {
                            return (<th scope="col">
                                <Moment format="ddd MMM  DD" withTitle>
                                    {moment(item)}
                                </Moment>
                            </th>)
                        })

                        }
                    </tr>
                    </thead>
                    <tbody>

                    {timeSchedule.map((item, index) => {
                        return (<tr key={index}>
                            <td style={{minHeight: '10px!important', overflow: 'hidden'}}>
                                <div className="row">
                                    <p className="col-8 slot" style={{
                                        fontWeight: (item[0].status === 'available') ? 'normal' : 'bold',
                                        color: (item[0].status === 'available') ? 'black' : 'green',
                                        cursor: (item[0].status !== 'booked') ? 'pointer' : '',
                                        textDecorationLine: (item[0].status === 'booked') ? 'line-through' : 'none',
                                    }}
                                       onClick={() => {
                                           addSchedule(item[0]) && addSchedule(item[0])
                                       }}
                                    >
                                        {moment(item[0].dateWithTime).format('HH:mm:A')}
                                    </p>
                                    {(item[0].status === 'booking') && (
                                        <p className="col-4" style={{color: 'red', fontWeight: 'bold', cursor: 'pointer'}}
                                           onClick={() => removeBookingSchedule(item[0].dateWithTime , item[0].studio_id)
                                                            }>X</p>
                                    )}
                                </div>
                            </td>
                            <td>
                                <div className="row">
                                    <p className="col-8 slot" style={{
                                        fontWeight: (item[1].status === 'available') ? 'normal' : 'bold',
                                        color: (item[1].status === 'available') ? 'black' : 'green',
                                        cursor: (item[1].status !== 'booked') ? 'pointer' : '',
                                        textDecorationLine: (item[1].status === 'booked') ? 'line-through' : 'none',
                                    }}
                                       onClick={() => {
                                           addSchedule(item[1]) && addSchedule(item[1])
                                       }}
                                    >
                                        {moment(item[1].dateWithTime).format('HH:mm:A')}
                                    </p>
                                    {(item[1].status === 'booking') && (
                                        <p className="col-4" style={{color: 'red', fontWeight: 'bold', cursor: 'pointer'}}
                                           onClick={() => removeBookingSchedule(item[1].dateWithTime,item[1].studio_id) }>X</p>
                                    )}
                                </div>
                            </td>

                            <td>
                                <div className="row">
                                    <p className="col-8 slot" style={{
                                        fontWeight: (item[2].status === 'available') ? 'normal' : 'bold',
                                        color: (item[2].status === 'available') ? 'black' : 'green',
                                        cursor: (item[2].status !== 'booked') ? 'pointer' : '',
                                        textDecorationLine: (item[2].status === 'booked') ? 'line-through' : 'none',
                                    }}
                                       onClick={() => {
                                           addSchedule(item[2]) && addSchedule(item[2])
                                       }}
                                    >
                                        {moment(item[2].dateWithTime).format('HH:mm:A')}
                                    </p>
                                    {(item[2].status === 'booking') && (
                                        <p className="col-4" style={{color: 'red', fontWeight: 'bold', cursor: 'pointer'}}
                                           onClick={() => removeBookingSchedule(item[2].dateWithTime , item[2].studio_id)}>X</p>
                                    )}
                                </div>
                            </td>

                            <td>
                                <div className="row">
                                    <p className="col-8 slot" style={{
                                        fontWeight: (item[3].status === 'available') ? 'normal' : 'bold',
                                        color: (item[3].status === 'available') ? 'black' : 'green',
                                        cursor: (item[3].status !== 'booked') ? 'pointer' : '',
                                        textDecorationLine: (item[3].status === 'booked') ? 'line-through' : 'none',
                                    }}
                                       onClick={() => {
                                           addSchedule(item[3]) && addSchedule(item[3])
                                       }}
                                    >
                                        {moment(item[3].dateWithTime).format('HH:mm:A')}
                                    </p>
                                    {(item[3].status === 'booking') && (
                                        <p className="col-4" style={{color: 'red', fontWeight: 'bold', cursor: 'pointer'}}
                                           onClick={() => removeBookingSchedule(item[3].dateWithTime , item[3].studio_id) }>X</p>
                                    )}
                                </div>
                            </td>

                            <td>
                                <div className="row">
                                    <p className="col-8 slot" style={{
                                        fontWeight: (item[4].status === 'available') ? 'normal' : 'bold',
                                        color: (item[4].status === 'available') ? 'black' : 'green',
                                        cursor: (item[4].status !== 'booked') ? 'pointer' : '',
                                        textDecorationLine: (item[4].status === 'booked') ? 'line-through' : 'none',
                                    }}
                                       onClick={() => {
                                           addSchedule(item[4]) && addSchedule(item[4])
                                       }}
                                    >
                                        {moment(item[4].dateWithTime).format('HH:mm:A')}
                                    </p>
                                    {(item[4].status === 'booking') && (
                                        <p className="col-4" style={{color: 'red', fontWeight: 'bold', cursor: 'pointer'}}
                                           onClick={() => removeBookingSchedule(item[4].dateWithTime , item[4].studio_id)}>X</p>
                                    )}
                                </div>
                            </td>

                            <td>
                                <div className="row">
                                    <p className="col-8 slot" style={{
                                        fontWeight: (item[5].status === 'available') ? 'normal' : 'bold',
                                        color: (item[5].status === 'available') ? 'black' : 'green',
                                        cursor: (item[5].status !== 'booked') ? 'pointer' : '',
                                        textDecorationLine: (item[5].status === 'booked') ? 'line-through' : 'none',
                                    }}
                                       onClick={() => {
                                           addSchedule(item[5]) && addSchedule(item[5])
                                       }}
                                    >
                                        {moment(item[5].dateWithTime).format('HH:mm:A')}
                                    </p>
                                    {(item[5].status === 'booking') && (
                                        <p className="col-4" style={{color: 'red', fontWeight: 'bold', cursor: 'pointer'}}
                                           onClick={() => removeBookingSchedule(item[5].dateWithTime , item[5].studio_id)}>X</p>
                                    )}
                                </div>
                            </td>

                            <td>
                                <div className="row">
                                    <p className="col-8 slot" style={{
                                        fontWeight: (item[6].status === 'available') ? 'normal' : 'bold',
                                        color: (item[6].status === 'available') ? 'black' : 'green',
                                        cursor: (item[6].status !== 'booked') ? 'pointer' : '',
                                        textDecorationLine: (item[6].status === 'booked') ? 'line-through' : 'none',
                                    }}
                                       onClick={() => {
                                           addSchedule(item[6]) && addSchedule(item[6])
                                       }}
                                    >
                                        {moment(item[6].dateWithTime).format('HH:mm:A')}
                                    </p>
                                    {(item[6].status === 'booking') && (
                                        <p className="col-4" style={{color: 'red', fontWeight: 'bold', cursor: 'pointer'}}
                                           onClick={() => removeBookingSchedule(item[6].dateWithTime , item[6].studio_id)}>X</p>
                                    )}
                                </div>
                            </td>

                        </tr>);
                    })}

                    </tbody>
                </table>
            </div>
        </div>
    );
}
export default CalendarSlot;
