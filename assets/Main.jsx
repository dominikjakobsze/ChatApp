import React from "react";
import HomeMain from "./pages/home/HomeMain";
import Menu from "./ui/Menu";
import Container from "./ui/Container";

const Main = () => {
    return (
        <>
            <Container>
                <Menu/>
                <HomeMain/>
            </Container>
        </>
    );
};

export default Main;