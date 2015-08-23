<?php



class Edge{

	public $source = "";
	public $sink = "";
	public $capacity = "";

	public function __construct($aSource, $aSink, $aCapacity){
		$this->source = $aSource;
		$this->sink = $aSink;
		$this->capacity = $aCapacity;
	}

}



class Node{

	public $name = "";

	public function __construct($aName){
		$this->name = $aName;
	}

}

class Clusterizer{
	
	public $project = "";
	public $powerFactor = 2;
	public $inflationFactor = 2;

	public $edges = array();

	// contains objects with
	// ->name = node name
	// other fields for data associated to node
	public $nodes = array();
    public $nodeMap = array();

	public function __construct( $aPowerFactor, $anInflationFactor) {

		$this->project = $research_code;
		$this->powerFactor = $aPowerFactor;
		$this->inflationFactor = $anInflationFactor;

		$this->edges = array();
		$this->nodes = array();
		$this->nodeMap = array();

		$this->loadGraph();

	}


	public function addNode($node){
		$found = false;

		//echo("Adding node:\n");
		//print_r($node);
		//echo("\n");


		for($i=0; $i<count($this->nodes) && !$found;$i++){
			if($this->nodes[$i]->name==$node->name){
				$found = true;
			}
		}
		if(!$found){
			$this->nodes[] = $node;
	        $this->nodeMap[$node->name] = count($this->nodes)-1;
	        $this->edges[$node->name] = array();	
		}

		//print_r($this->nodes);
		//echo("---------------\n");
    }


    // Add an edge from source to sink with capacity (invoked with nodes)
    public function addEdge($source, $sink, $capacity) {
        // Create the two edges = one being the reverse of the other
        $edge = new Edge($source->name, $sink->name, $capacity);
        $this->edges[$source->name][] = $edge;
    }
    
    // Does edge from source to sink exist?
    public function edgeExists($source, $sink) {
    	$res = null;
        if(  isset( $this->edges[$source->name] ) ){ 
            for($i=0;$i<count($this->edges[$source->name]);$i++){
                if($this->edges[$source->name][$i]->sink == $sink->name){
                    $res = $this->edges[$source->name][$i];
                }
            }
        }
		return $res;   
    }


    // Turn the set of nodes and edges to a matrix with the value being
    // the capacity between the nodes
    public function getAssociatedMatrix() {
        $matrix = array();
        for($i=0;$i<count($this->nodes);$i++) {
            $row = array();
            for($j=0;$j<count($this->nodes);$j++) {
                $edge = $this->edgeExists($this->nodes[$j], $this->nodes[$i]);
                if($i == $j){
                	$edge = new Edge(null,null,1);	
                } 
                $row[]= ($edge != null ? $edge->capacity : 0);
            }
            $matrix[] = $row;
        }
        return $matrix;
    }


    // Normalizes a given matrix
    public function normalize($matrix) {
        // Find the sum of each column
        $sums = array();
        for($col=0;$col<count($matrix);$col++) {
            $sum = 0;
            for($row=0;$row<count($matrix);$row++)
                $sum = $sum + $matrix[$row][$col];
            $sums[$col] = $sum;
        }

        // For every value in the matrix divide by the sum
        for($col=0;$col<count($matrix);$col++){ 
            for($row=0;$row<count($matrix);$row++){
            	if($sums[$col]!=0){
            		$matrix[$row][$col] = $matrix[$row][$col] / $sums[$col];
            	} else {
            		$matrix[$row][$col] = $matrix[$row][$col];
            	}
            }
        }
    }


    // Prints the matrix
    public function printMatrix($matrix) {
        for($i=0;$i<count($matrix);$i++) {
            for($j=0;$j<count($matrix[$i]);$j++) {
                echo(($j==0?'':',') . $matrix[$i][$j]);
            }
            echo("<br />");
        }
    }


    // Take the (power)th power of the matrix effectively multiplying it with
    // itself pow times
    public function matrixExpand($matrix, $pow) {
        $resultMatrix = array();
        for($row=0;$row<count($matrix);$row++) {
            $resultMatrix[$row] = array();
            for($col=0;$col<count($matrix);$col++) {
                $result = 0;
                for($c=0;$c<count(matrix);$c++){
                    $result = $result + $matrix[$row][$c] * $matrix[$c][$col];
                }
                $resultMatrix[$row][$col] = $result;
            }
        }
        return $resultMatrix;
    }

    // Applies a power of X to each item in the matrix
    public function matrixInflate($matrix, $pow) {
        for($row=0;$row<count($matrix);$row++){
            for($col=0;$col<count($matrix);$col++){
                $matrix[$row][$col] = pow($matrix[$row][$col], $pow);
            }
        }
    }

    // Are the two matrices equal?
    public function equals($a,$b) {
        for($i=0;$i<count($a);$i++) 
            for($j=0;$j<count($a[$i]);$j++) 
                if( !isset($b[$i]) || !isset($b[$i][$j]) || ($a[$i][$j] - $b[$i][$j]) > 0.1) return false;
        return true;
    }

    public function getMarkovCluster($power, $inflation) {
        $lastMatrix = array();
        
        $currentMatrix = $this->getAssociatedMatrix();

        
        $this->normalize($currentMatrix); 

        
        
        $currentMatrix = $this->matrixExpand($currentMatrix, $power);

        
        $this->matrixInflate($currentMatrix, $inflation);

        
        $this->normalize($currentMatrix);


        
        $c = 0;
        while(!$this->equals($currentMatrix,$lastMatrix)) {
            $lastMatrix = array_slice($currentMatrix,0);

            $currentMatrix = $this->matrixExpand($currentMatrix, $power);                
            $this->matrixInflate($currentMatrix, $inflation);         
            $this->normalize($currentMatrix);            
            
            $c++;
            if(c > 500) break; //JIC, fiddle fail
        }
        return $currentMatrix;
    }

	public function loadGraph(){
		// mettere il caricamento del grafo

		require_once('db.php');

		$res = array();


		$q1 = "SELECT DISTINCT nick1,nick2,c FROM relations WHERE research='" . $research_code . "' LIMIT 0,1000";
		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

				$n1 = new Node($row1["nick1"]);
				$n2 = new Node($row1["nick2"]);
				$c = $row1["c"];

				$this->addNode($n1);
				$this->addNode($n2);
				$this->addEdge($n1,$n2,$c);
				
			}
		}

		//print_r($this->nodes);
		//print_r($this->edges);
	}


}


$c = new Clusterizer(2,2);
$result = $c->getMarkovCluster(2,2);

echo(json_encode($result));


?>