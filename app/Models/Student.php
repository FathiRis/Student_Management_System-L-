use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_name','mobile_no','email','course','index_no','dob','gender',
        'father_name','father_no','mother_name','mother_no',
        'address','address2','message'
    ];
}
