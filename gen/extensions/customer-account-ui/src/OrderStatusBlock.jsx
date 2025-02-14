import {
    Card,
    Grid,
    BlockStack,
    Heading,
    Text,
    reactExtension,
    useAuthenticatedAccountCustomer,
    useApi,
} from '@shopify/ui-extensions-react/customer-account';
import React, { useState } from 'react';
import { useEffect } from 'react';

export default reactExtension(
    'customer-account.profile.block.render',
    () => <Extension />,
);

function Extension() {
    const customer = useAuthenticatedAccountCustomer();

    useEffect(() => {
        console.log(customer);

    }, [customer]);


    return (
        <Card padding>
            <Grid
                columns={['fill', 'auto']}
                spacing="base"
                minInlineSize="fill"
                blockAlignment="start"
            >
                <BlockStack spacing="loose">
                    <Heading>Loyalty Points</Heading>
                </BlockStack>
                <BlockStack spacing="loose">
                    <Text appearance="accent">Add</Text>
                </BlockStack>
            </Grid>
        </Card>
    );
}
