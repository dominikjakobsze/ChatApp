import React from "react";

const Container = ({children}) => {
    return (
        <div className={"w-full h-full flex flex-col max-w-[1400px] bg-gray-300"}>
            {children}
        </div>
    );
};

export default Container;