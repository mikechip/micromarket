import {Alert, Badge, Button, Card, Col, Figure, Row} from "react-bootstrap";
import {useState} from "react";
import {IItem} from "../../lib/entities";
import {query} from "../../lib/api";

export const Item = (props) => {
    const [error, setError] = useState('');
    const item: IItem = props?.data;

    const deselect = () => {
        if(props?.deselect) {
            props.deselect();
        }
    };

    const deleteItem = () => {
        query('catalog/delete', {id: item.id}).then((r) => {
            if(r.error?.text) {
                setError(r.error.text);
            } else if(r.response && ("result" in r.response)) {
                deselect();
            }
        });
    };

    return <>
        {(error?.length > 0) && <Alert variant={"danger"}>
            {error}
        </Alert>}

        {(item?.id > 0) && <Col>
            <Row>
                <Col md={4} sm={12}>
                    <Figure>
                        <Figure.Image
                            width={'80%'}
                            alt={item.title} src={item.image_url}
                        />
                    </Figure>
                </Col>
                <Col>
                    <h3>{item.title}</h3>
                    <h5>
                        Идентификатор: <Badge bg="secondary">{item.id}</Badge>
                    </h5>
                    <h5>
                        Цена: <Badge bg="secondary">{item.price} рублей</Badge>
                    </h5>
                </Col>
            </Row>
            <Card>
                <Card.Body>
                    {item.desc}
                </Card.Body>
                <Card.Footer>
                    <Button variant="primary" disabled>Редактировать</Button>{' '}
                    <Button variant="danger" onClick={() => deleteItem()}>Удалить</Button>
                </Card.Footer>
            </Card>
        </Col>}
    </>
}
