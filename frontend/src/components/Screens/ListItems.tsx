import {Alert, Card, Col, ListGroup, Row, Spinner} from "react-bootstrap";
import React, {useEffect, useState} from "react";
import {query} from "../../lib/api";
import {IItem, IResponseItemsList} from "../../lib/entities";

// @todo
export const ListItems = (props) => {
    const [loading, setLoading] = useState(true);
    const [items, setItems] = useState<IResponseItemsList>({count: 0, list: []});

    useEffect(() => {
        query('catalog/list', {}).then((r) => {
            if(r.response && ("list" in r.response)) {
                setItems(r.response);
                setLoading(false);
            }
        });
    }, []);

    const openItem = (data: IItem) => {
        if(props?.open) {
            props?.open(data);
        }
    }

    return <>
        <Col md={10} lg={10} sm={12}>
            {loading && <Spinner animation="border" style={{ margin: '0.5rem' }} />}

            {(!loading && !items?.count) && <Alert variant="warning">Товары не найдены</Alert>}

            {items?.count > 0 && <Row>
                {items.list.map(e => (
                    <Card onClick={() => openItem(e)}
                          style={{ width: '15rem', margin: '0.5rem', cursor: 'pointer' }} key={e.id}>
                        <Card.Img variant="top" src={e.image_url} />
                        <Card.Body>
                            <Card.Title>{e.title}</Card.Title>
                            <Card.Text>
                                {e.desc?.substr(0, 150)}{(e.desc?.length > 150) && '...'}
                            </Card.Text>
                            <Card.Footer>
                                {e.price} руб.
                            </Card.Footer>
                        </Card.Body>
                    </Card>
                ))}
            </Row>}
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
