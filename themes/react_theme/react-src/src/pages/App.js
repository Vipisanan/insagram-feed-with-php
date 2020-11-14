import React , {Component} from "react";
import "./App.css";

class App extends Component{
    constructor(props){
        super(props);
        this.state = {
            data:[]
        }
    }

    componentDidMount(){
        return fetch ("http://localhost/wordpress/index.php/wp-json/wp/v2/posts/")
            .then((response) =>response.json())
            .then((responseJson)=>{
                this.setState({data:responseJson});
            })
    }

    render(){
        const {data} = this.state;
        return (
            <div className="App">
                {data.map((post , index) =>{
                   return ( <div>
                        <h1>{post.title.rendered}</h1>
                        {post.content.rendered}
                    </div>)
                })}
            </div>
        );
    }
}
export default App;
