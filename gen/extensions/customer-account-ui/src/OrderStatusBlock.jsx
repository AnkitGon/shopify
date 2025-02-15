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
import axios from 'axios';

export default reactExtension(
    'customer-account.profile.block.render',
    () => <Extension />,
);

function Extension() {
    const customerId = useAuthenticatedAccountCustomer();
    const [myPoints, setmyPoints] = useState(1);

    useEffect(() => {
        const fetchCustomerPoints = async () => {
            try{
                const res = await axios.get(`https://shopify-ankit.test/api/customer-points/${customerId.id}`)

                setmyPoints(res.data.data);
            }catch(error){
                console.error("Error fetching points:", error);
            }
        }

        fetchCustomerPoints();

    }, [customerId]);


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
                    <Text appearance="accent">{myPoints}</Text>
                </BlockStack>
            </Grid>
        </Card>
    );
}
