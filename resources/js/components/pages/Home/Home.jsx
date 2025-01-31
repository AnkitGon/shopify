import React from 'react'
import { Page, Text } from '@shopify/polaris';

export default function Home() {
    return (
        <Page
            title="Home page"
            subtitle="Subtitle dekhega bhosdiwale"
        >
            <Text> {location.hostname} Fucking nice!</Text>
        </Page>
    )
}

