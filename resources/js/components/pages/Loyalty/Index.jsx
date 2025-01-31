import { Page, Card, TextField, Button, Form, FormLayout } from '@shopify/polaris';
import { useState, useCallback, useEffect } from 'react';
import axios from '../../../config/axiosConfig';
import { useAppBridge } from '@shopify/app-bridge-react';

export default function LoyaltySettings() {
    const shopify = useAppBridge();

    const [formData, setFormData] = useState({
        points_per_dollar: '',
        redemption_rate: '',
    });

    const handleChange = (field) => (value) => {
        setFormData((prev) => ({
            ...prev,
            [field]: value,
        }));
    };

    const getRecord = useCallback(async () => {
        try {
            const response = await axios.get('/loyalty-settings');

            setFormData({
                points_per_dollar: response.data.data.points_per_dollar || '',
                redemption_rate: response.data.data.redemption_rate || '',
            });
        } catch (error) {
            console.error('Error fetching record:', error);
        }
    }, []);

    useEffect(() => {
        getRecord();
    }, [getRecord]);

    const handleSubmit = useCallback(
        async (e) => {
            e.preventDefault();

            try {
                const response = await axios.post('/loyalty-settings', formData);

                if (response.data.success) {
                    shopify.toast.show('Loyalty settings saved');
                }

                getRecord();

            } catch (error) {
                if (error.status === 422) {
                    shopify.toast.show(error.response.data.message);
                }
            }
        },
        [formData]
    );

    return (
        <Page title="Loyalty Program Settings">
            <Card>
                <Form onSubmit={handleSubmit}>
                    <FormLayout>

                        <TextField
                            value={formData.points_per_dollar}
                            onChange={handleChange('points_per_dollar')}
                            label="Points Per Thousand Spent"
                            type="number"
                        />

                        <TextField
                            value={formData.redemption_rate}
                            onChange={handleChange('redemption_rate')}
                            label="Redemption Rate (RS per point)"
                            type="number"
                        />

                        <Button submit>Submit</Button>
                    </FormLayout>
                </Form>
            </Card>
        </Page>
    );
}
