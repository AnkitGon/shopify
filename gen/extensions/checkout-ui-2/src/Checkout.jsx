import {
    reactExtension,
    Banner,
    Text,
    useApi,
} from '@shopify/ui-extensions-react/checkout';
import axios from 'axios';
import { useState } from 'react';
import { useEffect } from 'react';
// 1. Choose an extension target
export default reactExtension(
    'purchase.checkout.payment-method-list.render-after',
    () => <Extension />,
);

function Extension() {
    const [pointsPerDollar, setPointsPerDollar] = useState(1);

    const { cost } = useApi();

    const cartTotal = cost.totalAmount.current.amount;

    useEffect(() => {
        const fetchPointPerSpent = async () => {
            try{
                const res = await axios.get('https://shopify-ankit.test/api/loyalty-settings')

                setPointsPerDollar(res.data.data.points_per_dollar);
            }catch(error){
                console.error("Error fetching points:", error);
            }
        }

        fetchPointPerSpent();

    }, [cartTotal]);


    const earnablePoints = (cartTotal / 1000) * pointsPerDollar;
    // 2. Render a UI
    return (
        <Banner status="info">
            <Text size="medium" emphasis="bold">You will earn {earnablePoints} points on this purchase.</Text>
        </Banner>
    );

}
