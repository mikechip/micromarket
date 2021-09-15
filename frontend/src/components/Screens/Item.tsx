import {useRouteMatch} from "react-router";
import {Alert, Badge, Button, Card, Col, Figure, Row} from "react-bootstrap";
import {useEffect, useState} from "react";
import {query} from "../../lib/api";
import {IItem} from "../../lib/entities";

// @todo
export const Item = () => {
    const [error, setError] = useState('');
    const [item, setItem] = useState<IItem>({id: 0, desc: "...", image_url: "/logo192.png", price: 0, title: "..."});
    const match = useRouteMatch('/item/:id');
    const params: any = match?.params;

    useEffect(() => {
        if(!params || !("id" in params)) {
            setError('Неверный ID');
            return;
        }

        const id: number = params.id;
        query('catalog/item', {id: id}).then((r) => {
            if(r.error) {
                setError(r.error.text);
            } else if(r.response && "item" in r.response) {
                setItem(r.response.item);
            }
        });
    }, []);

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
                    <Button variant="danger" disabled>Удалить</Button>
                </Card.Footer>
            </Card>
        </Col>}
    </>
}
