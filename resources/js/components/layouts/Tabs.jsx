
import { NavMenu } from '@shopify/app-bridge-react'
import React from 'react'

function Tabs() {

    return (
        <>
            <NavMenu>
                <a href="/" rel="home">Home</a>
                <a href="/loyalty-program">Loyalty Program</a>
            </NavMenu>
        </>
    )
}

export default Tabs
