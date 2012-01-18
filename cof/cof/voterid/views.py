# Create your views here.
from django.shortcuts import render_to_response

def index(request):
    return render_to_response("index.html", {
	"message": "Welcome to the Cost of Freedom App.",
    })
