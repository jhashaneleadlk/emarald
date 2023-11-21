import { Badge } from 'reactstrap';

const Status = (cell) => {
    switch(cell.value) {
        case "Active":
            return <Badge className="bg-success">Active</Badge>
        case "New":
            return <Badge className="bg-info">New</Badge>
        case "Deactivate":
            return <Badge className="bg-danger">Deactivate</Badge>
    }
};

export {Status}
