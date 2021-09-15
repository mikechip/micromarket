import {Alert, Card, CardGroup, Col, ListGroup} from "react-bootstrap";
import React, {useEffect, useState} from "react";
import {query} from "../../lib/api";
import {IResponseItemsList} from "../../lib/entities";
import {useHistory} from "react-router";

// @todo
export const ListItems = () => {
    const history = useHistory();
    const [items, setItems] = useState<IResponseItemsList>({count: 0, list: []});

    useEffect(() => {
        query('catalog/list', {}).then((r) => {
            if(r.response && ("list" in r.response)) {
                setItems(r.response);
            }
        });
    }, []);

    return <>
        <Col md={9} lg={9} sm={12}>
            {!items.count && <Alert variant="warning">Товары не найдены</Alert>}

            {items.count > 0 && <CardGroup>
                {items.list.map(e => (
                    <Card onClick={() => history.push('/item/' + e.id)} key={e.id}
                          style={{ width: '18rem', marginBottom: '0.5rem', cursor: 'pointer' }}>
                        <Card.Img variant="top" src={e.image_url} />
                        <Card.Body>
                            <Card.Title>{e.title}</Card.Title>
                            <Card.Text>
                                {e.desc}
                            </Card.Text>
                            <Card.Footer>
                                {e.price} руб.
                            </Card.Footer>
                        </Card.Body>
                    </Card>
                ))}
            </CardGroup>}
        </Col>
        <Col>
            <ListGroup defaultActiveKey="main">
                <ListGroup.Item active>
                    Список товаров
                </ListGroup.Item>
                <ListGroup.Item action disabled>
                    Сортировка
                </ListGroup.Item>
                <ListGroup.Item action disabled>
                    Добавить товар
                </ListGroup.Item>
            </ListGroup>
        </Col>
    </>;
}
