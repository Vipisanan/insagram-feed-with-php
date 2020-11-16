import React from 'react';
import '../pages/style/component.css'

const InstaGallery = ({instaFeed}) =>{
    console.log(instaFeed)
    return(
        <div >
            <h2 className="heading"><strong>Insta</strong> Gallery</h2>
            <div className="container">
                <div className="card-columns">
                    {instaFeed.map((item, index)=>{
                        return (
                            <div className="card ">
                            <img className="card-img-top"
                                 src={item.media_url}
                            />

                        </div>
                        )})}
                </div>
            </div>

        </div>
    )
}
export default  InstaGallery;
